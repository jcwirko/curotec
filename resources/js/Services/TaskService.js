import axios from "axios";

export const getTasks = async (params = {}) => {
    const response = await axios.get("/api/tasks", { params });
    return response.data.data;
};

export const createTask = async (taskData) => {
    const response = await axios.post("/api/tasks", taskData);
    return response.data;
};

export function updateTask(id, data) {
    return axios.patch(`/api/tasks/${id}`, data)
}
