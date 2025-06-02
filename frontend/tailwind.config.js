/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx,css}"],
  theme: {
    extend: {
      backgroundImage: {
        "login-img": "url('/img/LoginImg.png')",
      },
      fontFamily: {
        roboto: ["Roboto", "sans-serif"],
      },
      colors: {
        netflix: {
          red: "#E50914",
          redHover: "#F40612",
          redDark: "#C11119",
          blackWithOpacity: "rgba(0, 0, 0, 0.7)",
        },
      },
    },
  },
  plugins: [],
};
