import { useRef, useState } from "react";
import env from "../bootstrap/env";
import Api from "../services/Api";

function ResultWidget({ shortUrl, callback }) {
  const originalCode = shortUrl.split("/").pop();

  const [code, setCode] = useState(originalCode);
  const [error, setError] = useState("");
  const [customizeMode, setCustomizeMode] = useState(false);

  const inputBox = useRef(null);

  const cancelEdit = () => {
    setCustomizeMode(false);
    setCode(originalCode);
  };

  const customizeUrl = async () => {
    const response = await Api.customize(originalCode, code).catch((e) => {
      inputBox.current.focus();
      setError(e.error);
    });
    if (response) {
      setError("");
      setCustomizeMode(false);
      callback(response.shortUrl);
    }
  };

  return (
    <div className="position-relative">
      <div className="card">
        {!customizeMode && (
          <div className="card-body">
            <a target="_blank" rel="noreferrer" href={shortUrl}>
              {shortUrl}
            </a>
          </div>
        )}

        {customizeMode && (
          <div className="p-3">
            <div className="input-group input-group-lg">
              <div className="input-group-prepend">
                <span className="input-group-text" id="input-addon">
                  {env.baseUrl}
                </span>
              </div>
              <input
                type="text"
                ref={inputBox}
                className="form-control"
                aria-describedby="input-addon"
                onChange={(e) => setCode(e.target.value)}
                value={code}
              />
            </div>
            <span className="text-danger">{error}</span>
          </div>
        )}

        <div className="card-footer">
          {!customizeMode && (
            <>
              <button
                className="btn btn-success btn-small"
                onClick={(e) => setCustomizeMode(true)}
              >
                Customize link
              </button>
              &emsp;
              <button
                className="btn btn-warning btn-small"
                onClick={(e) => callback("")}
              >
                Go back
              </button>
            </>
          )}

          {customizeMode && (
            <>
              <button
                className="btn btn-primary btn-small"
                disabled={!code.trim()}
                onClick={customizeUrl}
              >
                Save changes
              </button>
              &emsp;
              <button
                className="btn btn-warning btn-small"
                onClick={cancelEdit}
              >
                Cancel
              </button>
            </>
          )}
        </div>
      </div>
    </div>
  );
}

export default ResultWidget;
