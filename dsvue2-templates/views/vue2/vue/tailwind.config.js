module.exports = {
  important: true,
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
    container: {
      padding: {
        '2xl': '8rem'
      }
    }
  },
  variants: {
    extend: {}
  },
  plugins: []
}
