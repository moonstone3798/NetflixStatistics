import api from "@/axios/axios.js";
export const getLanguages = async () => {
  try {
    const url = `/idiomas/get_idiomas.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editLanguage = async (params) => {
  try {
    const query = {
      id: params.id,
      idioma: params.idioma,
    };
    const url = `/idiomas/put_idiomas.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addLanguage = async (params) => {
  try {
    const query = {
      idioma: params.idioma,
    };
    const url = `/idiomas/post_idiomas.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteLanguage = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/idiomas/delete_idiomas.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
