import api from "@/axios/axios.js";
export const login = async (params) => {
  try {
    const url = `/api/Login.php`;
    const payload = {
      mail: params.email,
      contrasenia: params.password,
    };
    await api.post(url, payload);
    return { status: "success" };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const register = async (params) => {
  try {
    const url = `/registro.php`;
    const payload = {
      nombre: params.name,
      apellido: params.lastName,
      mail: params.email,
      contrasenia: params.password,
    };
    await api.post(url, payload);
    return { status: "success" };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
