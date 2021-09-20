import React from 'react';
import { VisionNavigationLinks } from '../../enums';

import './index.scss';

import WaitingRoomCard from './components/WaitingRoomClientCard';
import WaitingRoomGroupCard from './components/WaitingRoomGroupCard';
import WaitingRoomTable from './components/WaitingRoomTable';
import { useClientSide } from './useClientSide';
import Loader from '../../../../components/Loader/Loader';

const ClientSide = () => {
  const { isLoading, reception } = useClientSide();

  if (isLoading) return <Loader />;

  console.log(reception);

  return (
    <div className="vision-client-side">
      <WaitingRoomTable clients={reception} />

      <div className="room-cards">
        <WaitingRoomCard
          title="Кімната №1"
          headerButtonTitle="Переглянути"
          headerButtonLink={`${VisionNavigationLinks.clientSide}/1`}
        />

        <WaitingRoomCard
          title="Кімната №1"
          headerButtonTitle="Переглянути"
          headerButtonLink={`${VisionNavigationLinks.clientSide}/2`}
        />

        <WaitingRoomCard
          title="Кімната №1"
          headerButtonTitle="Переглянути"
          headerButtonLink={`${VisionNavigationLinks.clientSide}/3`}
        />

        <WaitingRoomGroupCard
          title="Кімната №1"
          headerButtonTitle="Запросити"
          onHeaderButtonClick={() => console.log('test')}
        />
      </div>
    </div>
  );
};

export default ClientSide;
