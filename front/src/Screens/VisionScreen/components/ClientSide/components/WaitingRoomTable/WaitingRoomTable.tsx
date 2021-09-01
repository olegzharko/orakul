import * as React from 'react';
import { useState } from 'react';
import { waitingRoomClientsTableHeader } from '../../config';

import WaitingRoomClientItem from '../WaitingRoomClientTableItem';

const WaitingRoomTable = () => {
  const [selectedIndex, setSelectedIndex] = useState<number>(-1);

  const handleClick = (index: number) => {
    setSelectedIndex(selectedIndex === index ? -1 : index);
  };

  return (
    <table className="vision-client-side__table">
      <thead className="table__header">
        <tr>
          <th colSpan={8}>Приймальня</th>
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

        <WaitingRoomClientItem
          index={0}
          height={selectedIndex === 0 ? 'auto' : 0}
          onClick={handleClick}
        />

        <WaitingRoomClientItem
          index={1}
          height={selectedIndex === 1 ? 'auto' : 0}
          onClick={handleClick}
        />

        <WaitingRoomClientItem
          index={2}
          height={selectedIndex === 2 ? 'auto' : 0}
          onClick={handleClick}
        />
      </tbody>
    </table>
  );
};

export default WaitingRoomTable;
