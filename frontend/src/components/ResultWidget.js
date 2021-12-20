function ResultWidget({ shortUrl, callback }) {
  return (
    <div className="position-relative">
      <div className="card">
        <div className="card-body">
          <a target="_blank" rel="noreferrer" href={shortUrl}>
            {shortUrl}
          </a>
        </div>
        <div className="card-footer">
            <a className="btn btn-success btn-small">Customize link</a>
            &emsp;
            <a className="btn btn-warning btn-small" onClick={e => callback('')}>Go back</a>
        </div>
      </div>
    </div>
  );
}

export default ResultWidget;
