import api from "@/axios/axios.js";
export const getProductionTypes = async () => {
  try {
    const url = `/tipos_producciones/get_tipos_produccion.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const editProductionType = async (params) => {
  try {
    const query = {
      id: params.id,
      nombre: params.nombre,
    };
    const url = `/tipos_producciones/put_tipos_produccion.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addProductionType = async (params) => {
  try {
    const query = {
      nombre: params.nombre,
    };
    const url = `/tipos_producciones/post_tipos_produccion.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteProductionType = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/tipos_producciones/delete_tipos_produccion.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
