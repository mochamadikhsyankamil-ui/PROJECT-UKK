import React, { useRef } from "react";
import SignatureCanvas from "react-signature-canvas";

export default function ReturnSignatureModal() {
    const sign1 = useRef();
    const sign2 = useRef();
    const sign3 = useRef();
    const sign4 = useRef();

    const submitForm = () => {
        document.getElementById("r_input1").value = sign1.current.toDataURL();
        document.getElementById("r_input2").value = sign2.current.toDataURL();
        document.getElementById("r_input3").value = sign3.current.toDataURL();
        document.getElementById("r_input4").value = sign4.current.toDataURL();
    };

    const Pad = ({ refPad }) => (
        <SignatureCanvas
            ref={refPad}
            penColor="black"
            canvasProps={{
                className: "border w-full h-28"
            }}
        />
    );

    return (
        <div>
            <p className="font-semibold mb-2">Operator Sign</p>
            <Pad refPad={sign1} />
            <Pad refPad={sign2} />

            <p className="font-semibold mt-4 mb-2">Borrower Sign</p>
            <Pad refPad={sign3} />
            <Pad refPad={sign4} />

            <button
                type="button"
                onClick={submitForm}
                className="hidden"
                id="reactSubmitSign"
            >
                submit
            </button>
        </div>
    );
}
