export const useUser = () => {
  const validateEmailFormat = (email) => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  };
  const validatePasswordFormat = (password) => {
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]{3,}$/;
    return regex.test(password);
  };
  const passwordValidations = [
    {
      condition: (value) => !value,
      message: "La contraseña es obligatoria",
    },
    {
      condition: (value) => value.length < 3,
      message: "La contraseña debe tener al menos 3 caracteres",
    },
    {
      condition: (value) => value.length > 20,
      message: "La contraseña no puede tener más de 20 caracteres",
    },
    {
      condition: (value) => !validatePasswordFormat(value),
      message: "La contraseña debe contener al menos una letra y un número",
    },
  ];
  const emailValidations = [
    {
      condition: (value) => !value,
      message: "El email es obligatorio",
    },
    {
      condition: (value) => !validateEmailFormat(value),
      message: "El email no tiene un formato válido",
    },
  ];
  return {
    validateEmailFormat,
    validatePasswordFormat,
    passwordValidations,
    emailValidations,
  };
};
