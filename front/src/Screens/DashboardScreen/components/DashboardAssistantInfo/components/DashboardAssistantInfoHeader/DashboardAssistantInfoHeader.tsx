import React from 'react';

import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

const DashboardAssistantInfoHeader = () => (
  <div className="assistant-info-header">
    <div className="assistant-info-header__person">
      <img src="/images/empty-logo.svg" alt="logo" />
      <span>Жарко Олег Володимирович</span>
    </div>
    <div className="assistant-info-header__buttons">
      <PrimaryButton
        label="Завдання"
        onClick={() => console.log('click')}
      />
      <SecondaryButton
        label="Зауваження"
        onClick={() => console.log('click')}
        disabled={false}
      />
    </div>
  </div>
);

export default DashboardAssistantInfoHeader;
