import axios from "axios";

const api = axios.create({
    baseURL: "http://location_review.test/api",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    },
});

export default api;
