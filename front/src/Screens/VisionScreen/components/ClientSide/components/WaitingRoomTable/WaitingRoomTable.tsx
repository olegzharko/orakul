import * as React from 'react';
import { useCallback, useState } from 'react';

import { waitingRoomClientsTableHeader } from '../../config';
import { VisionClientResponse } from '../../types';

import WaitingRoomClientItem from '../WaitingRoomClientTableItem';

type WaitingRoomTableProps = {
  clients: VisionClientResponse[];
  onFinishClient: (cardId: number) => void;
}

const WaitingRoomTable = ({ clients, onFinishClient }: WaitingRoomTableProps) => {
  const [selectedIndex, setSelectedIndex] = useState<number>(-1);

  const handleClick = useCallback((index: number) => {
    setSelectedIndex(selectedIndex === index ? -1 : index);
  }, [setSelectedIndex, selectedIndex]);

  const handleFinishClick = useCallback((cardId: number) => {
    setSelectedIndex(-1);
    onFinishClient(cardId);
  }, [setSelectedIndex, onFinishClient]);

  return (
    <table className="vision-client-side__table">
      <thead className="table__header">
        <tr>
          <th colSpan={8} className="vision-section-title">Приймальня</th>
        </tr>
      </thead>

      <tbody className="table__body">
        <tr>
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
            onFinish={handleFinishClick}
            client={client}
          />
        ))}
      </tbody>
    </table>
  );
};

export default WaitingRoomTable;
