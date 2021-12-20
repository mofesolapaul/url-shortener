import { useState } from "react";
import "./App.css";
import ResultWidget from "./components/ResultWidget";
import ShortenerWidget from "./components/ShortenerWidget";

function App() {
  const [shortUrl, setShortUrl] = useState("");

  return (
    <div className="container h-100 d-flex align-items-center justify-content-center">
      <div className="w-75 text-center">
        <h1 className="title">
          Url Shortener <small className="muted small">v1.0</small>
        </h1>
        {!shortUrl && <ShortenerWidget callback={setShortUrl} />}
        {shortUrl && <ResultWidget shortUrl={shortUrl} callback={setShortUrl} />}
      </div>
    </div>
  );
}

export default App;
