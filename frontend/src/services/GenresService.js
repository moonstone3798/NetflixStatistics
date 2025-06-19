import api from "@/axios/axios.js";
export const getGenres = async () => {
  try {
    const url = `/generos/get_generos.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editGenre = async (params) => {
  try {
    const query = {
      id: params.id,
      nombre: params.nombre,
    };
    const url = `/generos/put_generos.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addGenre = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
    };
    const url = `/generos/post_generos.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteGenre = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/generos/delete_generos.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
