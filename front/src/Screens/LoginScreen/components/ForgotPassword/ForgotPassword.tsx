import React, { memo } from 'react';
import { Link } from 'react-router-dom';
import CustomInput from '../../../../components/CustomInput';
import Modal from '../../../../components/Modal';
import { useModal } from '../../../../components/Modal/useModal';
import PrimaryButton from '../../../../components/PrimaryButton';
import { useForgotPassword } from './useForgotPassword';

const ForgotPassword = () => {
  const meta = useForgotPassword();

  return (
    <>
      <form className="login__forgot" onSubmit={meta.handleReset}>
        <img src="/icons/logo-full.svg" alt="Rakul" />
        <h1 className="login__forgot-title mv12">Відновлення паролю</h1>

        <div className="mv12">
          <CustomInput
            label="E-mail"
            value={meta.email}
            onChange={meta.setEmail}
          />
        </div>

        <div className="mv12">
          <PrimaryButton
            label="Відновити пароль"
            onClick={meta.handleReset}
            disabled={meta.disabledButton}
          />
        </div>

        <Link to="/" className="link">
          Повернутися до авторизації
        </Link>
      </form>
    </>
  );
};

export default memo(ForgotPassword);
