import env from "../bootstrap/env";
import axios from "axios";

const Api = {
  apiUrl: env.apiUrl,
  shorten: async function (fullUrl) {
    return await axios.post(`${this.apiUrl}/shorten`, { fullUrl });
  },
};

axios.interceptors.response.use(
  (response) => {
    return response.data;
  },
  (error) => {
    const response = error.response.data;
    return Promise.reject(response);
  }
);

export default Api;
