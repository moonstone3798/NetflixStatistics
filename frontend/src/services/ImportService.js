import api from "@/axios/axios.js";
export const bulkImport = async (params) => {
  try {
    const url = `/importar.php`;
    const payload = {
      file: params.file,
      type: params.type,
    };
    const response = await api.post(url, payload);
    return { status: "success", data: response.data };
  } catch (error) {
    console.error("Error: ", error);
    return { status: "error" };
  }
};
