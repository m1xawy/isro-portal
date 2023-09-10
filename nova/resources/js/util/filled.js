import isNil from 'lodash/isNil'

export default function filled(value) {
  return Boolean(!isNil(value) && value !== '')
}
