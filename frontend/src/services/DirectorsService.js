import api from "@/axios/axios.js";
export const getDirectors = async () => {
  try {
    const url = `/directores/get_directores.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editDirector = async (params) => {
  try {
    const query = {
      id: params.id,
      nombre: params.nombre,
    };
    const url = `/directores/put_directores.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addDirector = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
    };
    const url = `/directores/post_directores.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteDirector = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/directores/delete_directores.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
