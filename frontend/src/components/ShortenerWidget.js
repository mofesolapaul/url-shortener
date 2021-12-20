import { useRef, useState } from "react";
import Api from "../services/Api";

function ShortenerWidget({ callback }) {
  const [url, setUrl] = useState("");
  const [error, setError] = useState("");
  const inputBox = useRef(null);

  const shortenUrl = async (e) => {
    e.preventDefault();
    const response = await Api.shorten(url).catch((e) => {
      inputBox.current.focus();
      setError(e.error);
    });
    if (response) {
      setError("");
      callback(response.shortUrl);
    }
  };

  return (
    <form onSubmit={shortenUrl}>
      <div className="form-group">
        <input
          type="text"
          ref={inputBox}
          className="form-control form-control-lg"
          placeholder="paste your link"
          value={url}
          onChange={(e) => setUrl(e.target.value)}
          autoFocus={true}
        />
        <span className="text-danger">{error}</span>
      </div>
      <button
        type="submit"
        className={`btn btn-primary btn-lg`}
        disabled={!url.trim()}
      >
        Shorten Url
      </button>
    </form>
  );
}

export default ShortenerWidget;
