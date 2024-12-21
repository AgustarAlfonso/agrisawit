/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
     "./node_modules/flowbite/**/*.js",
    "./resources/**/*.vue",
    
  ],  theme: { 
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
    require('daisyui'),
    require('@tailwindcss/forms'),// Tambahkan ini
  ],
}

