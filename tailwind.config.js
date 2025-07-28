import flowbite from 'flowbite/plugin'
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
      './node_modules/flowbite/**/*.js',
      './node_modules/daisyui/**/*.js',
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('flowbite/plugin'),
      require('daisyui'),
    ],
  }
  