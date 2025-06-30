import api from "@/axios/axios.js";
export const getQueries = async () => {
  try {
    const url = `/querys/get_querys.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const processQuery = async (params) => {
  try {
    const query = {
      query: params.query,
    };
    const url = `/procesar_query.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
