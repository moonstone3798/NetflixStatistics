import Swal from "sweetalert2";
export const useMessage = () => {
  const showAlert = ({ title, text, icon }) => {
    Swal.fire({
      title,
      text,
      icon,
      showConfirmButton: false,
      timer: 2500,
      background: "#050505",
      color: "#f1f1f1",
      iconColor: icon === "success" ? "#0bde35" : "#E50914",
      customClass: {
        popup: "swal2-dark swal-rounded",
      },
    });
  };
  return {
    showAlert,
  };
};
