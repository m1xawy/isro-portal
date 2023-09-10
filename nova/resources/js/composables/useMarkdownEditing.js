import { ref, computed, watch, nextTick } from 'vue'
import CodeMirror from 'codemirror'
import each from 'lodash/each'
import isNil from 'lodash/isNil'
import { useLocalization } from '@/composables/useLocalization'

const { __ } = useLocalization()

const defineMarkdownCommands = (
  editor,
  { props, emit, isFocused, filesCount, filesUploaded }
) => {
  const doc = editor.getDoc()

  return {
    setValue(value) {
      doc.setValue(value)
      this.refresh()
    },

    focus() {
      isFocused.value = true
    },

    refresh() {
      nextTick(() => editor.refresh())
    },

    insert(insertion) {
      let cursor = doc.getCursor()

      doc.replaceRange(insertion, {
        line: cursor.line,
        ch: cursor.ch,
      })
    },

    insertAround(start, end) {
      if (doc.somethingSelected()) {
        const selection = doc.getSelection()

        doc.replaceSelection(start + selection + end)
      } else {
        let cursor = doc.getCursor()

        doc.replaceRange(start + end, {
          line: cursor.line,
          ch: cursor.ch,
        })

        doc.setCursor({
          line: cursor.line,
          ch: cursor.ch + start.length,
        })
      }
    },

    insertBefore(insertion, cursorOffset) {
      if (doc.somethingSelected()) {
        const selects = doc.listSelections()
        selects.forEach(selection => {
          const pos = [selection.head.line, selection.anchor.line].sort()

          for (let i = pos[0]; i <= pos[1]; i++) {
            doc.replaceRange(insertion, { line: i, ch: 0 })
          }

          doc.setCursor({ line: pos[0], ch: cursorOffset || 0 })
        })
      } else {
        let cursor = doc.getCursor()

        doc.replaceRange(insertion, {
          line: cursor.line,
          ch: 0,
        })
        doc.setCursor({
          line: cursor.line,
          ch: cursorOffset || 0,
        })
      }
    },

    uploadAttachment(file) {
      if (!isNil(props.uploader)) {
        filesCount.value = filesCount.value + 1

        const placeholder = `![Uploading ${file.name}…]()`

        this.insert(placeholder)

        props.uploader(file, {
          onCompleted: url => {
            let value = doc.getValue()
            value = value.replace(placeholder, `![${file.name}](${url})`)

            doc.setValue(value)
            emit('change', value)

            filesUploaded.value = filesUploaded.value + 1
          },
          onFailure: error => {
            filesCount.value = filesCount.value - 1
          },
        })
      }
    },
  }
}

const defineMarkdownActions = (commands, { isEditable, isFullScreen }) => {
  return {
    bold() {
      if (!isEditable) return

      commands.insertAround('**', '**')
    },

    italicize() {
      if (!isEditable) return

      commands.insertAround('*', '*')
    },

    image() {
      if (!isEditable) return

      commands.insertBefore('![](url)', 2)
    },

    link() {
      if (!isEditable) return

      commands.insertAround('[', '](url)')
    },

    toggleFullScreen() {
      isFullScreen.value = !isFullScreen.value

      commands.refresh()
    },

    fullScreen() {
      isFullScreen.value = true

      commands.refresh()
    },

    exitFullScreen() {
      isFullScreen.value = false

      commands.refresh()
    },
  }
}

const defineMarkdownKeyMaps = (editor, actions) => {
  const keyMaps = {
    'Cmd-B': 'bold',
    'Cmd-I': 'italicize',
    'Cmd-Alt-I': 'image',
    'Cmd-K': 'link',
    F11: 'fullScreen',
    Esc: 'exitFullScreen',
  }

  each(keyMaps, (action, map) => {
    const realMap = map.replace(
      'Cmd-',
      CodeMirror.keyMap['default'] == CodeMirror.keyMap.macDefault
        ? 'Cmd-'
        : 'Ctrl-'
    )

    editor.options.extraKeys[realMap] = actions[keyMaps[map]].bind(this)
  })
}

const defineMarkdownEvents = (editor, commands, { props, emit, isFocused }) => {
  const doc = editor.getDoc()

  const handlePasteFromClipboard = e => {
    if (e.clipboardData && e.clipboardData.items) {
      const items = e.clipboardData.items

      for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
          commands.uploadAttachment(items[i].getAsFile())

          e.preventDefault()
        }
      }
    }
  }

  editor.on('focus', () => (isFocused.value = true))
  editor.on('blur', () => (isFocused.value = false))

  doc.on('change', (cm, changeObj) => {
    if (changeObj.origin !== 'setValue') {
      emit('change', cm.getValue())
    }
  })

  editor.on('paste', (cm, event) => {
    handlePasteFromClipboard(event)
  })

  watch(isFocused, (currentValue, oldValue) => {
    if (currentValue === true && oldValue === false) {
      editor.focus()
    }
  })
}

const bootstrap = (
  theTextarea,
  {
    emit,
    props,
    isEditable,
    isFocused,
    isFullScreen,
    filesCount,
    filesUploaded,
    unmountMarkdownEditor,
  }
) => {
  const editor = CodeMirror.fromTextArea(theTextarea.value, {
    tabSize: 4,
    indentWithTabs: true,
    lineWrapping: true,
    mode: 'markdown',
    viewportMargin: Infinity,
    extraKeys: {
      Enter: 'newlineAndIndentContinueMarkdownList',
    },
    readOnly: props.readonly,
  })

  const doc = editor.getDoc()

  const commands = defineMarkdownCommands(editor, {
    props,
    emit,
    isFocused,
    filesCount,
    filesUploaded,
  })
  const actions = defineMarkdownActions(commands, { isEditable, isFullScreen })

  defineMarkdownKeyMaps(editor, actions)

  defineMarkdownEvents(editor, commands, { props, emit, isFocused })

  commands.refresh()

  return {
    editor,
    unmount: () => {
      editor.toTextArea()
      unmountMarkdownEditor()
    },
    actions: {
      ...commands,
      ...actions,
      handle(context, action) {
        if (!props.readonly) {
          isFocused.value = true
          actions[action].call(context)
        }
      },
    },
  }
}

export function useMarkdownEditing(emit, props) {
  const isFullScreen = ref(false)
  const isFocused = ref(false)
  const previewContent = ref('')
  const visualMode = ref('write')
  const statusContent = ref(
    __('Attach files by dragging & dropping, selecting or pasting them.')
  )
  const filesCount = ref(0)
  const filesUploaded = ref(0)

  const isEditable = computed(
    () => props.readonly && visualMode.value == 'write'
  )

  const unmountMarkdownEditor = () => {
    isFullScreen.value = false
    isFocused.value = false
    visualMode.value = 'write'
    previewContent.value = ''
    filesCount.value = 0
    filesUploaded.value = 0
  }

  if (!isNil(props.uploader)) {
    watch(
      [filesUploaded, filesCount],
      ([currentFilesUploaded, currentFilesCount]) => {
        if (currentFilesCount > currentFilesUploaded) {
          statusContent.value = __('Uploading files... (:current/:total)', {
            current: currentFilesUploaded,
            total: currentFilesCount,
          })
        } else {
          statusContent.value = __(
            'Attach files by dragging & dropping, selecting or pasting them.'
          )
        }
      }
    )
  }

  return {
    createMarkdownEditor: (context, theTextarea) => {
      return bootstrap.call(context, theTextarea, {
        emit,
        props,
        isEditable,
        isFocused,
        isFullScreen,
        filesCount,
        filesUploaded,
        unmountMarkdownEditor,
      })
    },
    isFullScreen,
    isFocused,
    isEditable,
    visualMode,
    previewContent,
    statusContent,
  }
}
