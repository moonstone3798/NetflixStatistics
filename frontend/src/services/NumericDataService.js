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
export const addNumericData = async (params) => {
  try {
    const url = `/datos_extras/post_datos_extras.php`;
    const query = {
      popularidad: params.popularidad,
      votos: params.votos,
      rating: params.rating,
      promedio_votos: params.promedio_votos,
      presupuesto: params.presupuesto,
      ganancia: params.ganancia,
    };
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editNumericData = async (params) => {
  try {
    const url = `/datos_extras/put_datos_extras.php`;
    const query = {
      id: params.id,
      popularidad: params.popularidad,
      votos: params.votos,
      rating: params.rating,
      promedio_votos: params.promedio_votos,
      presupuesto: params.presupuesto,
      ganancia: params.ganancia,
    };
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteNumericData = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/datos_extras/delete_datos_extras.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
