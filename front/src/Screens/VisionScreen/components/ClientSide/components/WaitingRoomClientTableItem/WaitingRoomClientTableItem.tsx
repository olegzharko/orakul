import React, { useCallback } from 'react';
import AnimateHeight from 'react-animate-height';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

type WaitingRoomClientTableItemProps = {
  height: number | string;
  index: number;
  onClick: (index: number) => void;
}

const DEFAULT_DURATION = 500;

const WaitingRoomClientTableItem = (
  { onClick, height, index }: WaitingRoomClientTableItemProps
) => {
  const handleClose = useCallback(() => {
    onClick(-1);
  }, []);

  return (
    <>
      <tr className="table__clickable" onClick={() => onClick(index)}>
        <td style={{ backgroundColor: '#FF3400' }} />
        <td>13:00</td>
        <td>13:00</td>
        <td>13:00</td>
        <td>13:00</td>
        <td>13:00</td>
        <td>13:00</td>
        <td>13:00</td>
      </tr>
      <AnimateHeight
        duration={DEFAULT_DURATION}
        height={height}
      >
        <div className="table__info">
          <div className="table__closeIcon">
            <img src="/images/x.svg" alt="close" onClick={handleClose} />
          </div>
          <div className="grid-center-trio">
            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                Петрова Світлана Миколаївна
              </span>
            </div>
          </div>

          <div className="table__buttonsGroup">
            <SecondaryButton
              label="Редагувати"
              onClick={() => console.log('click')}
              disabled={false}
            />
            <SecondaryButton
              label="Переглянути"
              onClick={() => console.log('click')}
              disabled={false}
            />
            <PrimaryButton
              label="Завершити послугу"
              onClick={() => console.log('click')}
            />
          </div>

        </div>
      </AnimateHeight>
    </>
  );
};

export default WaitingRoomClientTableItem;
