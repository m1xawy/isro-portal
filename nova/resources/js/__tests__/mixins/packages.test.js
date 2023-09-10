import { useLocalization } from '@/mixins/packages'

afterAll(() => {
  delete global.Nova
})

test('it can use localization', () => {
  const { __ } = useLocalization()

  global.Nova = {
    config(key) {
      return this.appConfig[key] ?? null
    },
    appConfig: {
      translations: {
        taylorotwell: 'Taylor Otwell',
        'Laravel Nova :version': 'Laravel Nova v:version',
      },
    },
  }

  expect(__('taylorotwell')).toBe('Taylor Otwell')
  expect(__('Laravel Nova')).toBe('Laravel Nova')
  expect(__('Laravel Nova :version', { version: '4.0.0' })).toBe(
    'Laravel Nova v4.0.0'
  )
})
