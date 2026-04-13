import './bootstrap';
import React from "react";
import ReactDOM from "react-dom/client";
import ReturnSignatureModal from "./components/ReturnSignatureModal";

const el = document.getElementById("react-return-modal");

if (el) {
    ReactDOM.createRoot(el).render(<ReturnSignatureModal />);
}
