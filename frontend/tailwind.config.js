/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx,css}"],
  theme: {
    extend: {
      backgroundImage: {
        "login-img": "url('/img/LoginImg.png')",
        "register-img": "url('/img/RegisterImg.png')",
        "home-img": "url('/img/HomeImg.png')",
      },
      fontFamily: {
        roboto: ["Roboto", "sans-serif"],
      },
      colors: {
        netflix: {
          red: "#E50914",
          redHover: "#EB3942",
          redDark: "#C11119",
          blackWithOpacity: "rgba(0, 0, 0, 0.65)",
          gray: "#808080",
          gray50: "#BCBCBC",
          gray100: "#BDBCBB",
          gray200: "#E8D1D1",
        },
      },
    },
  },
  plugins: [],
};
