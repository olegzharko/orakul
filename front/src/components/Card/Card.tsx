import * as React from 'react';
import './index.scss';
import ReactHtmlParser from 'react-html-parser';

type Props = {
  title: string;
  children: React.ReactNode;
  headerColor?: string;
  haveStatus?: boolean;
  onClick?: () => void;
}

const Card = ({ title, headerColor, children, haveStatus, onClick }: Props) => {
  const getTextColor = () => {
    if (haveStatus) return 'black';
    if (headerColor) return 'white';

    return '';
  };

  const getTitleBackgroundColor = () => {
    if (haveStatus) return '';
    if (headerColor) return headerColor;

    return '';
  };

  return (
    <div className={`card ${onClick ? '' : 'disabled'}`} onClick={onClick}>
      <div className="card__header" style={{ backgroundColor: getTitleBackgroundColor() }}>
        <span style={{ color: getTextColor() }}>{ReactHtmlParser(title)}</span>
        {haveStatus && (
          <div className="status" style={{ backgroundColor: headerColor || '' }} />
        )}
      </div>
      <div className="card__main">
        {children}
      </div>
    </div>
  );
};

export default Card;
