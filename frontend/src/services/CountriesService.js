import api from "@/axios/axios.js";
export const getCountries = async () => {
  try {
    const url = `/paises/get_paises.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editCountry = async (params) => {
  try {
    const query = {
      id: params.id,
      nombre: params.nombre,
    };
    const url = `/paises/put_paises.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addCountry = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
    };
    const url = `/paises/post_paises.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteCountry = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/paises/delete_paises.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
