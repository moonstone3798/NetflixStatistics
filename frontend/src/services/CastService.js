import api from "@/axios/axios.js";
export const getCasts = async () => {
  try {
    const url = `/repartos/get_repartos.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editCast = async (params) => {
  try {
    const query = {
      id: params.id,
      nombre: params.nombre,
    };
    const url = `/repartos/put_repartos.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addCast = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
    };
    const url = `/repartos/post_repartos.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteCast = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/repartos/delete_repartos.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
