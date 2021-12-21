import { fireEvent, render, screen } from "@testing-library/react";
import App from "./App";

describe("Check app layout", function () {
  beforeEach(function () {
    render(<App />);
  });

  it("renders app header", () => {
    const headerElement = screen.getByText(/Url Shortener/i);
    expect(headerElement).toBeInTheDocument();
  });
  
  it("renders input box with default focus", () => {
    const inputBox = screen.getByPlaceholderText(/paste your link/i);
    expect(inputBox).toBeInTheDocument();
    expect(inputBox).toHaveFocus();
  });
  
  it("renders submit button", () => {
    const submitButton = screen.getByText(/Shorten Url/i);
    expect(submitButton).toBeInTheDocument();
    expect(submitButton).toBeDisabled();
  });
  
  it("activates submit button on valid input", () => {
    const inputBox = screen.getByPlaceholderText(/paste your link/i);
    const submitButton = screen.getByText(/Shorten Url/i);

    fireEvent.change(inputBox, {target: {value: '   '}});
    expect(submitButton).toBeDisabled();

    fireEvent.change(inputBox, {target: {value: 'hello'}});
    expect(submitButton).toBeEnabled();
  });
});
