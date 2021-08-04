import { useMemo } from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../../store/types';

export type Props = {
  rows: any;
  columns: any;
  rooms: any;
};

export type RoomWithBackground = {
  index: number;
  colour: string;
}

export const useGridTable = (props: Props) => {
  const newSelectedAppointment = useSelector(
    (state: State) => state.scheduler.newSelectedAppointment
  );

  // eslint-disable-next-line array-callback-return
  const roomsWithBackground = useMemo(() => {
    const separatedRooms: RoomWithBackground[] = [];
    props.rooms.forEach((room: any, index: number) => {
      if (room.color) {
        separatedRooms.push({ index, colour: room.color });
      }
    });

    return separatedRooms;
  }, []);

  return { newSelectedAppointment, roomsWithBackground };
};
