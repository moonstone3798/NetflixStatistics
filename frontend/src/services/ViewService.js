import api from "@/axios/axios.js";
export const getViews = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/vistas/get_vistas.php`;
    const response = await api.get(url, { params: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addView = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
      id_query: params.id_query,
      id_tipo: params.id_tipo,
      id_usuario: params.id_usuario,
    };
    const url = `/vistas/post_vistas.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
