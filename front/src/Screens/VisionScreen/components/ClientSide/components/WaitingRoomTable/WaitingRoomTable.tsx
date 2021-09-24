import * as React from 'react';
import { useCallback, useState } from 'react';
import { PostDealUpdate } from '../../../../../../services/vision/space/postDealUpdate';

import { waitingRoomClientsTableHeader } from '../../config';
import { VisionClientResponse } from '../../types';

import WaitingRoomClientItem from '../WaitingRoomClientTableItem';

type WaitingRoomTableProps = {
  clients: VisionClientResponse[];
  onFinishClient: (dealId: number) => void;
  onUpdateClient: (updatedData: PostDealUpdate) => void;
}

const WaitingRoomTable = ({ clients, onFinishClient, onUpdateClient }: WaitingRoomTableProps) => {
  const [selectedIndex, setSelectedIndex] = useState<number>(-1);

  const handleClick = useCallback((index: number) => {
    setSelectedIndex(selectedIndex === index ? -1 : index);
  }, [setSelectedIndex, selectedIndex]);

  const handleFinishClick = useCallback((dealId: number) => {
    setSelectedIndex(-1);
    onFinishClient(dealId);
  }, [setSelectedIndex, onFinishClient]);

  return (
    <table className="vision-client-side__table">
      <thead className="table__header">
        <tr>
          <th colSpan={8} className="vision-section-title">Приймальня</th>
        </tr>
      </thead>

      <tbody className="table__body">
        <tr className="table__body-grid">
          <td />
          {waitingRoomClientsTableHeader.map(({ title, icon }) => (
            <td key={title}>
              <img src={`/images/${icon}`} alt="clock" />
              {title}
            </td>
          ))}
        </tr>

        {clients.map((client, index) => (
          <WaitingRoomClientItem
            key={client.card_id}
            index={index}
            height={selectedIndex === index ? 'auto' : 0}
            onClick={handleClick}
            onSave={onUpdateClient}
            onFinish={handleFinishClick}
            client={client}
          />
        ))}
      </tbody>
    </table>
  );
};

export default WaitingRoomTable;
