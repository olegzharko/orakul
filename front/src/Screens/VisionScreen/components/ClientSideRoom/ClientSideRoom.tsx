import React from 'react';

import './index.scss';
import ClientSideRoomSubscriber from './components/ClientSideRoomSubscriber';
import ClientSideRoomTime from './components/ClientSideRoomTime';
import ClientSideRoomStages from './components/ClientSideRoomStages';
import ClientSideRoomPayments from './components/ClientSideRoomPayments';
import ClientSideRoomImmovables from './components/ClientSideRoomImmovables';
import ClientSideRoomHelp from './components/ClientSideRoomHelp';
import ClientSideRoomCompleteSet from './components/ClientSideRoomCompleteSet';
import ClientSideRoomOther from './components/ClientSideRoomOther';

const ClientSideRoom = () => (
  <div className="vision-client-side-room">
    <div className="vision-client-side-room__header" style={{ backgroundColor: '#04BC00' }}>
      <span>Кімната №2</span>
    </div>
    <div className="vision-client-side-room__body">
      <ClientSideRoomTime />
      <ClientSideRoomSubscriber />
      <ClientSideRoomStages />
      <ClientSideRoomPayments />
      <ClientSideRoomImmovables />
      <ClientSideRoomHelp />
      <ClientSideRoomCompleteSet />
      <ClientSideRoomOther />
    </div>
  </div>
);

export default ClientSideRoom;
