import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: 'https://localhost',
    headers: {
        'Content-Type': 'application/json',
    },
});

export default axiosInstance;
