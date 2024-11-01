import purgecss from '@fullhuman/postcss-purgecss'

export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
    '@fullhuman/postcss-purgecss': {
      content: [
        './src/**/*.vue',
        './src/**/*.js'
      ],
      defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],
      ...purgecss
    }
  }
}
