import api from "@/axios/axios.js";
export const getProductions = async () => {
  try {
    const url = `/producciones/get_producciones.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
