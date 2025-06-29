import api from "@/axios/axios.js";
export const getNumericData = async () => {
  try {
    const url = `/datos_extras/get_datos_extras.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
