import { fireEvent, render, screen } from "@testing-library/react";
import ResultWidget from "./ResultWidget";

describe("Check result widget", function () {
  const testUrl = "https://localhost/cv3XYm2";
  const callbackProp = jest.fn();

  beforeEach(function () {
    render(<ResultWidget shortUrl={testUrl} callback={callbackProp} />);
  });

  it("displays short url and action buttons to user", () => {
    const linkElement = screen.getByText(testUrl);
    const customizeButton = screen.getByText(/Customize link/i);
    const backButton = screen.getByText(/Go back/i);

    expect(linkElement).toBeInTheDocument();
    expect(customizeButton).toBeInTheDocument();
    expect(backButton).toBeInTheDocument();
  });

  test("on click, back button invokes callback", () => {
    const backButton = screen.getByText(/Go back/i);
    fireEvent.click(backButton);
    expect(callbackProp).toHaveBeenCalledWith("");
  });

  test("non-customization controls get hidden", () => {
    const linkElement = screen.getByText(testUrl);
    const customizeButton = screen.getByText(/Customize link/i);
    const backButton = screen.getByText(/Go back/i);

    fireEvent.click(customizeButton);
    [linkElement, customizeButton, backButton].forEach((element) =>
      expect(element).not.toBeVisible()
    );
  });

  test("customization controls are shown", () => {
    const customizeButton = screen.getByText(/Customize link/i);
    fireEvent.click(customizeButton);

    const saveButton = screen.getByText(/Save changes/i);
    const cancelButton = screen.getByText(/Cancel/i);

    const shortCode = testUrl.split('/').pop();
    const shortCodeInput = screen.getByDisplayValue(shortCode);

    [saveButton, cancelButton, shortCodeInput].forEach((element) =>
      expect(element).toBeVisible()
    );
  });
});
