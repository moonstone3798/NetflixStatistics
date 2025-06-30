import api from "@/axios/axios.js";
export const getProductions = async () => {
  try {
    const url = `/producciones/get_producciones.php`;
    const response = await api.get(url);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const addProduction = async (params) => {
  try {
    const query = {
      id_tipo_produccion: params.tipo_produccion,
      titulo: params.titulo,
      fecha_ingreso: params.fecha_ingreso,
      anio_realizacion: params.anio_realizacion,
      duracion: params.duracion,
      descripcion: params.descripcion,
      id_idioma: params.id_idioma,
      id_datos_extras: params.id_datos_extras,
    };
    const url = `/producciones/post_producciones.php`;
    const response = await api.post(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    const mensaje =
      error.response?.data?.mensaje ||
      "Error inesperado al crear la producción.";
    return { status: "error", data: mensaje };
  }
};
export const editProduction = async (params) => {
  try {
    const query = {
      id: params.id,
      id_tipo_produccion: params.id_tipo_produccion,
      titulo: params.titulo,
      fecha_ingreso: params.fecha_ingreso,
      anio_realizacion: params.anio_realizacion,
      duracion: params.duracion,
      descripcion: params.descripcion,
      id_idioma: params.id_idioma,
      id_datos_extras: params.id_datos_extras,
    };
    const url = `/producciones/put_producciones.php`;
    const response = await api.put(url, query);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
export const deleteProduction = async (params) => {
  try {
    const query = {
      id: params.id,
    };
    const url = `/producciones/delete_producciones.php`;
    const response = await api.delete(url, { data: query });
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
