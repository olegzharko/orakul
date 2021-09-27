import React from 'react';
import { useSelector } from 'react-redux';

import { State } from '../../../../../../store/types';

const DashboardAssistantInfoHeader = () => {
  const { avatar, user_name } = useSelector((state: State) => state.main.user);

  return (
    <div className="assistant-info-header">
      <div className="assistant-info-header__person">
        <img src={avatar || '/images/empty-logo.svg'} alt="logo" />
        <span>{user_name || ''}</span>
      </div>

      {/* todo add later */}
      {/* <div className="assistant-info-header__buttons">
        <PrimaryButton
          label="Завдання"
          onClick={() => console.log('click')}
        />
        <SecondaryButton
          label="Зауваження"
          onClick={() => console.log('click')}
          disabled={false}
        />
      </div> */}
    </div>
  );
};

export default DashboardAssistantInfoHeader;
