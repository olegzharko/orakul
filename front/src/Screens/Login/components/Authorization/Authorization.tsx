import * as React from 'react';
import { Link } from 'react-router-dom';
import Carousel from '../../../../components/Carousel/Carousel';
import CustomCheckBox from '../../../../components/CustomCheckBox';
import CustomInput from '../../../../components/CustomInput';
import CustomPasswordInput from '../../../../components/CustomPasswordInput';
import Loader from '../../../../components/Loader/Loader';
import PrimaryButton from '../../../../components/PrimaryButton';
import { useAuthorization } from './useAuthorization';

const Authorization = () => {
  const { images } = useAuthorization();

  return (
    <div className="login__container">
      <div className="login__carousel">
        {!images && <Loader />}
        {images && <Carousel images={images} />}
      </div>
      <div className="login__form">
        <img src="/icons/logo-full.svg" alt="Rakul" />

        <div className="mv12">
          <CustomInput label="E-mail" onChange={(val) => console.log(val)} />
        </div>

        <div className="mv12">
          <CustomPasswordInput
            label="Password"
            onChange={(val) => console.log(val)}
          />
        </div>

        <div className="mv12">
          <PrimaryButton
            label="Авторизуватися"
            onClick={() => console.log('click')}
            disabled={false}
          />
        </div>

        <div className="mv12">
          <CustomCheckBox
            label="Запам’ятати мене"
            onChange={(val) => console.log(val)}
          />
        </div>

        <Link to="/login/forgot" className="link">
          Забули пароль?
        </Link>
      </div>
    </div>
  );
};

export default Authorization;
