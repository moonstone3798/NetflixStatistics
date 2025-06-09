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
      condition: (password) => !password,
      message: "La contraseña es obligatoria",
    },
    {
      condition: (password) => password.length < 3,
      message: "La contraseña debe tener al menos 3 caracteres",
    },
    {
      condition: (password) => password.length > 20,
      message: "La contraseña no puede tener más de 20 caracteres",
    },
    {
      condition: (password) => !validatePasswordFormat(password),
      message: "La contraseña debe contener al menos una letra y un número",
    },
  ];
  const emailValidations = [
    {
      condition: (email) => !email,
      message: "El email es obligatorio",
    },
    {
      condition: (email) => !validateEmailFormat(email),
      message: "El email no tiene un formato válido",
    },
  ];
  const repeatPasswordValidations = [
    {
      condition: (password, repeatPassword) => password !== repeatPassword,
      message: "Las contraseñas deben coincidir",
    },
  ];
  const nameValidations = [
    {
      condition: (name) => !name,
      message: "El nombre es obligatorio",
    },
    {
      condition: (name) => name.length < 3,
      message: "El nombre debe tener al menos 3 caracteres",
    },
    {
      condition: (name) => name.length > 20,
      message: "El nombre debe tener como máximo 20 caracteres",
    },
  ];
  const lastNameValidations = [
    {
      condition: (lastName) => !lastName,
      message: "El apellido es obligatorio",
    },
    {
      condition: (lastName) => lastName.length < 2,
      message: "el apellido debe tener al menos 2 caracteres",
    },
  ];

  return {
    validateEmailFormat,
    validatePasswordFormat,
    passwordValidations,
    emailValidations,
    repeatPasswordValidations,
    nameValidations,
    lastNameValidations,
  };
};
