import __ from '../util/localization'

export function useLocalization() {
  return {
    __: (key, replace) => __(key, replace),
  }
}
