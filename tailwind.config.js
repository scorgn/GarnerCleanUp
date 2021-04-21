const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        primary: {
          "light": "#76BD7D",
          "semi-light": "#6aac6f",
          "DEFAULT": "#63a068",
          "dark": "#518356",
          "light-deep": "#5CC076",
          "deep": "#4ca362"
        },
        cyan: colors.cyan,
        'blue-gray': colors.blueGray
      },
      minWidth: {
        75: "75px",
      },
      borderWidth: {
        3: "3px"
      },
      boxShadow: {
        2: '1px 1px 3px 1px rgb(0 0 0 / 15%)',
        sharp: '0 0 1px 1px rgb(0 0 0 / 15%)',
      },
      minHeight: {
        600: "600px"
      },
      maxWidth: {
        "72px": "72px",
        "100px": "100px",
        "200px": "200px",
        "420px": "420px",
        "540px": "540px",
        "620px": "620px",
        "1200px": "1200px"
      },
      fontFamily: {
        "primary": "'Open Sans', sans-serif",
        "secondary": "'Bitter', serif"
      },
      animation: {
        "pulse-fast": "pulse 800ms cubic-bezier(0.4, 0, 0.6, 1) infinite",
        "pulse-fast-2x": "pulse 800ms cubic-bezier(0.4, 0, 0.6, 1) 2 forwards",
        "error": "shake 0.82s cubic-bezier(.36,.07,.19,.97) backwards;"
      },
      keyframes: {
        "shake": {
          "10%, 90%": {transform: "translate3d(-1px, 0, 0)"},
          "20%, 80%": {transform: "translate3d(2px, 0, 0)"},
          "30%, 50%, 70%": {transform: "translate3d(-4px, 0, 0)"},
          "40%, 60%": { transform: "translate3d(4px, 0, 0)" }
        }
      }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ]
}
