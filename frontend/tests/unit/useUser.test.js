import { describe, it, expect } from "vitest";
import { useUser } from "@/composables/useUser";

describe("useUser", () => {
  const {
    validateEmailFormat,
    validatePasswordFormat,
    emailValidations,
    passwordValidations,
    repeatPasswordValidations,
    nameValidations,
    lastNameValidations,
  } = useUser();

  it("valida formato de email correctamente", () => {
    expect(validateEmailFormat("usuario@dominio.com")).toBe(true);
    expect(validateEmailFormat("usuario@.com")).toBe(false);
    expect(validateEmailFormat("usuario")).toBe(false);
  });

  it("valida formato de contraseña correctamente", () => {
    expect(validatePasswordFormat("abc123")).toBe(true);
    expect(validatePasswordFormat("123456")).toBe(false);
    expect(validatePasswordFormat("abcdef")).toBe(false);
    expect(validatePasswordFormat("a1")).toBe(false);
  });

  it("devuelve mensaje correcto si email es vacío", () => {
    const error = emailValidations.find((v) => v.condition(""));
    expect(error.message).toBe("El email es obligatorio");
  });

  it("devuelve mensaje si contraseña no tiene número", () => {
    const error = passwordValidations.find((v) => v.condition("abcdef"));
    expect(error.message).toBe(
      "La contraseña debe contener al menos una letra y un número"
    );
  });

  it("devuelve mensaje si contraseña es muy larga", () => {
    const error = passwordValidations.find((v) => v.condition("a1".repeat(11)));
    expect(error.message).toBe(
      "La contraseña no puede tener más de 20 caracteres"
    );
  });

  it("devuelve mensaje si las contraseñas no coinciden", () => {
    const error = repeatPasswordValidations.find((v) =>
      v.condition("acd123", "123acd")
    );
    expect(error.message).toBe("Las contraseñas deben coincidir");
  });

  it("devuelve mensaje si el nombre tiene menos de 3 caracteres", () => {
    const error = nameValidations.find((v) => v.condition("Lu"));
    expect(error.message).toBe("El nombre debe tener al menos 3 caracteres");
  });

  it("devuelve mensaje si el apellido tiene menos de 2 caracteres", () => {
    const error = lastNameValidations.find((v) => v.condition("L"));
    expect(error.message).toBe("el apellido debe tener al menos 2 caracteres");
  });

  it("devuelve mensaje si se realiza registro sin contraseña", () => {
    const error = passwordValidations.find((v) => v.condition(""));
    expect(error.message).toBe("La contraseña es obligatoria");
  });

  it("devuelve mensaje si se realiza registro con un nombre de más de 20 caracteres", () => {
    const error = nameValidations.find((v) => v.condition("A".repeat(100)));
    expect(error.message).toBe(
      "El nombre debe tener como máximo 20 caracteres"
    );
  });

  it("devuelve mensaje correcto si email no tiene su respectivo formato", () => {
    const error = emailValidations.find((v) => v.condition("asd"));
    expect(error.message).toBe("El email no tiene un formato válido");
  });
});
