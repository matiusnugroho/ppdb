// config/endpoint.ts

// Define base URL for your API
const BASE_URL = '/'
const BASE_URL_API = '/api'

// Define endpoints
const ENDPOINTS = {
  BASE_URL,
  LOGIN: `${BASE_URL_API}/auth/login`,
  ME_SISWA: `${BASE_URL_API}/siswa/me`
}

// Helper function to replace placeholders with actual values
const replacePlaceholder = (url: string, params: Record<string, string | number>) => {
  return Object.keys(params).reduce((acc, key) => {
    return acc.replace(`{${key}}`, encodeURIComponent(params[key].toString()))
  }, url)
}

// Export endpoints and helper function
export { ENDPOINTS, replacePlaceholder }
