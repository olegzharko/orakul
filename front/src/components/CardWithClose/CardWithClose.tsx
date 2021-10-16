import * as React from 'react';
import './index.scss';

type Props = {
  title: string;
  children: React.ReactNode;
  onClick: () => void;
  onRemove: (id?: string) => void;
}

const CardWithClose = ({ title, children, onClick, onRemove }: Props) => {
  const handleClick = (e: any) => {
    e.preventDefault();
    onRemove();
  };

  return (
    <div className="card-close" onClick={onClick}>
      <div className="card-close__header">
        <span>{title}</span>
        <button
          type="button"
          onClick={handleClick}
          className="card-close__button"
        >
          <img src="/images/x.svg" alt="delete" />
        </button>
      </div>
      <div className="card-close__main">
        {children}
      </div>
    </div>
  );
};

export default CardWithClose;
