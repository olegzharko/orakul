import React, { useCallback } from 'react';
import AnimateHeight from 'react-animate-height';

import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

import { VisionClient } from '../../types';

type WaitingRoomClientTableItemProps = {
  height: number | string;
  index: number;
  client: VisionClient
  onClick: (index: number) => void;
}

const DEFAULT_DURATION = 500;

const WaitingRoomClientTableItem = ({
  height,
  index,
  client,
  onClick,
}: WaitingRoomClientTableItemProps) => {
  const handleClose = useCallback(() => {
    onClick(-1);
  }, []);

  return (
    <>
      <tr className="table__clickable" onClick={() => onClick(index)}>
        <td style={{ backgroundColor: '#FF3400' }} />
        <td>{client.start_time}</td>
        <td>{client.visit_time}</td>
        <td>{client.waiting_time}</td>
        <td>{client.people}</td>
        <td>{client.children}</td>
        <td>{client.in_progress}</td>
        <td>Добавить</td>
      </tr>
      <AnimateHeight
        duration={DEFAULT_DURATION}
        height={height}
      >
        <div className="table__info">
          <div className="table__closeIcon">
            <img src="/images/x.svg" alt="close" onClick={handleClose} />
          </div>
          <div className="grid-center-trio table__info-grid">
            <div className="table__textBlock">
              <span className="title">
                Нотаріус
              </span>
              <span className="info">
                {client.notary.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Читач
              </span>
              <span className="info">
                {client.reader.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Видавач
              </span>
              <span className="info">
                {client.accompanying.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Підписант
              </span>
              <span className="info">
                {client.representative.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Нерухомість
              </span>
              <span className="info">
                {client.immovable.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
              </span>
            </div>

            <div className="table__textBlock">
              <span className="title">
                Покупець
              </span>
              <span className="info">
                {client.buyer.map(({ title, id }) => (
                  <span key={id}>{title}</span>
                ))}
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
