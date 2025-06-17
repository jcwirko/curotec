import axios from "axios";

export const getCategories = async (params = {}) => {
    const response = await axios.get("/api/categories", { params });
    return response.data.data;
};
