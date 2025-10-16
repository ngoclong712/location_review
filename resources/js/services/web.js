import axios from "axios";

const web = axios.create({
    baseURL: "http://location_review.test",
    headers: { "X-Requested-With": "XMLHttpRequest" }, // Laravel web nhận AJAX
});

export default web;
