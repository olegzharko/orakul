import React from 'react';
import CustomCheckBox from '../CustomCheckBox';

import PrimaryButton from '../PrimaryButton';
import SecondaryButton from '../SecondaryButton';

import './index.scss';

const CheckList = () => (
  <div className="check-list">
    <div className="title">Чек-лист</div>
    <div className="list">
      <CustomCheckBox
        label="Аналіз документів"
        onChange={() => console.log('change')}
      />
      <CustomCheckBox
        label="Аналіз документів, що підтвержують особу"
        onChange={() => console.log('change')}
      />
      <CustomCheckBox
        label="Перевірка копій продавця"
        onChange={() => console.log('change')}
      />
      <CustomCheckBox
        label="Перевірка правовстановлюючих документів"
        onChange={() => console.log('change')}
      />
    </div>
    <div className="buttons">
      <PrimaryButton
        label="Готово"
        onClick={() => console.log('click')}
      />
      <SecondaryButton
        label="Зауваження"
        onClick={() => console.log('test')}
        disabled={false}
      />
    </div>
  </div>
);

export default CheckList;
