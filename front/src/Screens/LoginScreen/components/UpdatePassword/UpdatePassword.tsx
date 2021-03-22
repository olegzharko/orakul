import React, { memo } from 'react';
import { Link } from 'react-router-dom';
import CustomPasswordInput from '../../../../components/CustomPasswordInput';
import Modal from '../../../../components/Modal';
import { useModal } from '../../../../components/Modal/useModal';
import PrimaryButton from '../../../../components/PrimaryButton';
import { useUpdatePassword } from './useUpdatePassword';

const UpdatePassword = () => {
  const meta = useUpdatePassword();
  const { modalProps } = useModal();

  return (
    <>
      <form className="login__update" onSubmit={meta.handleUpdate}>
        <img src="/icons/logo-full.svg" alt="Rakul" />
        <h1 className="login__forgot-title mv12">Новий пароль</h1>

        <div className="mv12">
          <CustomPasswordInput
            label="Пароль"
            value={meta.password}
            onChange={meta.setPassword}
          />
        </div>

        <div className="mv12">
          <CustomPasswordInput
            label="Повторіть пароль"
            value={meta.repeatPassword}
            onChange={meta.setRepeatPassword}
          />
        </div>

        <div className="mv12">
          <PrimaryButton
            label="Відновити пароль"
            onClick={meta.handleUpdate}
            disabled={meta.disabledButton}
          />
        </div>

        <Link to="/" className="link">
          Повернутися до авторизації
        </Link>
      </form>
      <Modal {...modalProps} />
    </>
  );
};

export default UpdatePassword;
