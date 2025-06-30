import api from "@/axios/axios.js";
export const getGraphicTypes = async () => {
  try {
    const url = `/tipos_graficos/get_tipos_graficos.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
