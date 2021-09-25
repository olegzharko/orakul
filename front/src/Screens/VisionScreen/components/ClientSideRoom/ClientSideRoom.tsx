import React from 'react';

import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import ClientSideRoomRepresentatives from './components/ClientSideRoomRepresentatives';
import ClientSideRoomTime from './components/ClientSideRoomTime';
import ClientSideRoomStages from './components/ClientSideRoomStages';
import ClientSideRoomPayments from './components/ClientSideRoomPayments';
import ClientSideRoomImmovables from './components/ClientSideRoomImmovables';
import ClientSideRoomOther from './components/ClientSideRoomOther';
import { useClientSideRoom } from './useClientSideRoom';

const ClientSideRoom = () => {
  const {
    isLoading,
    header,
    time,
    representative,
    immovables,
    payments,
    stages,
    other,
  } = useClientSideRoom();

  if (isLoading) return <Loader />;

  return (
    <div className="vision-client-side-room">
      <div className="vision-client-side-room__header" style={{ backgroundColor: header?.color }}>
        <span>{header?.title}</span>
      </div>
      <div className="vision-client-side-room__body">
        <ClientSideRoomTime time={time} />
        <ClientSideRoomRepresentatives representatives={representative} />
        <ClientSideRoomImmovables immovables={immovables} />
        <ClientSideRoomOther other={other} />
        <ClientSideRoomPayments payments={payments} />

        {stages.map((stage) => (
          <ClientSideRoomStages
            key={stage.title}
            stage={stage}
          />
        ))}
      </div>
    </div>
  );
};

export default ClientSideRoom;
