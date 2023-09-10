export function useQueryParams() {
  const searchParams = new URLSearchParams(window.location.search)

  return { params: Object.fromEntries(searchParams.entries()) }
}
